import { computed, ref, watch } from 'vue';
import { COST_PER_VOTE } from '@/config/voting';
import { getContestStatusMessage, normalizeContestStatus, type ContestStatus } from '@/utils/contestStatus';

type StoredVoteCartEntry = {
    contestant_id: number;
    votes: number;
};

type CartStoragePayload = {
    version: number;
    items: StoredVoteCartEntry[];
};

type CartContestant = {
    id: number;
    contest_id: number | null;
    name: string;
    slug: string;
    image: string | null;
    contest_name: string;
    contest_status: string | null;
};

type AddableContestant = {
    id: number;
    contestId?: number | null;
    contestStatus?: string | null;
};

const STORAGE_KEY = 'vote_cart';
const CART_VERSION = 1;
const MAX_VOTES_PER_CONTEST = 50;

const cartNotice = ref('');
const isCartReady = ref(false);

const setCartNotice = (message: string) => {
    cartNotice.value = message;
};

const clearCartNotice = () => {
    cartNotice.value = '';
};

const persistEntries = (nextEntries: StoredVoteCartEntry[]) => {
    if (typeof window === 'undefined') {
        return;
    }

    const payload: CartStoragePayload = {
        version: CART_VERSION,
        items: nextEntries,
    };

    window.localStorage.setItem(STORAGE_KEY, JSON.stringify(payload));
};

const resetStoredCart = () => {
    if (typeof window !== 'undefined') {
        window.localStorage.removeItem(STORAGE_KEY);
    }
};

const sanitizeEntries = (entries: unknown): StoredVoteCartEntry[] => {
    if (!Array.isArray(entries)) {
        return [];
    }

    return entries
        .map((entry) => ({
            contestant_id: Number((entry as StoredVoteCartEntry | null)?.contestant_id),
            votes: Number((entry as StoredVoteCartEntry | null)?.votes),
        }))
        .filter((entry) => Number.isInteger(entry.contestant_id) && entry.contestant_id > 0)
        .map((entry) => ({
            contestant_id: entry.contestant_id,
            votes: Math.max(1, Number.isFinite(entry.votes) ? entry.votes : 1),
        }));
};

const loadEntries = (): StoredVoteCartEntry[] => {
    if (typeof window === 'undefined') {
        return [];
    }

    try {
        const storedValue = window.localStorage.getItem(STORAGE_KEY);
        if (!storedValue) {
            return [];
        }

        const parsedValue = JSON.parse(storedValue) as CartStoragePayload | StoredVoteCartEntry[];

        if (!parsedValue || Array.isArray(parsedValue)) {
            resetStoredCart();
            return [];
        }

        if (parsedValue.version !== CART_VERSION) {
            resetStoredCart();
            return [];
        }

        return sanitizeEntries(parsedValue.items);
    } catch {
        resetStoredCart();
        return [];
    }
};

const entries = ref<StoredVoteCartEntry[]>(loadEntries());
const contestantDetails = ref<Record<number, CartContestant>>({});

const currencyFormatter = new Intl.NumberFormat('en-NG', {
    style: 'currency',
    currency: 'NGN',
    maximumFractionDigits: 0,
});

const formatCurrency = (amount: number) => currencyFormatter.format(amount);

const setEntries = (nextEntries: StoredVoteCartEntry[]) => {
    entries.value = nextEntries;
    persistEntries(nextEntries);
};

const buildRemovalMessage = (removedCount: number, statuses: Array<ContestStatus | null> = []) => {
    if (removedCount <= 1) {
        const [status] = statuses;

        if (status === 'upcoming') {
            return 'Voting has not started yet, so this contestant has been removed from your cart.';
        }

        if (status === 'ended') {
            return 'Voting has ended, so this contestant has been removed from your cart.';
        }

        return 'This contestant is no longer available and has been removed from your cart.';
    }

    return 'Some contestants in your cart were no longer available and have been removed.';
};

const refreshCart = async () => {
    const contestantIds = [...new Set(entries.value.map((entry) => entry.contestant_id))];

    if (!contestantIds.length) {
        contestantDetails.value = {};
        isCartReady.value = true;
        return;
    }

    isCartReady.value = false;

    try {
        const params = new URLSearchParams();
        contestantIds.forEach((id) => params.append('ids[]', String(id)));

        const response = await fetch(`/contestants/cart-items?${params.toString()}`, {
            headers: {
                Accept: 'application/json',
            },
        });

        if (!response.ok) {
            return;
        }

        const payload = await response.json() as {
            contestants?: CartContestant[];
        };

        const fetchedContestants = (payload.contestants ?? []).map((contestant) => ({
            ...contestant,
            contest_status: normalizeContestStatus(contestant.contest_status),
        }));
        const contestantMap = fetchedContestants.reduce<Record<number, CartContestant>>((carry, contestant) => {
            carry[contestant.id] = contestant;
            return carry;
        }, {});
        const removedStatuses = fetchedContestants
            .filter((contestant) => contestant.contest_status && contestant.contest_status !== 'active')
            .map((contestant) => contestant.contest_status);
        const validEntries = entries.value.filter((entry) => {
            const contestant = contestantMap[entry.contestant_id];

            if (!contestant) {
                return false;
            }

            return contestant.contest_status === null || contestant.contest_status === 'active';
        });
        const removedCount = entries.value.length - validEntries.length;

        contestantDetails.value = validEntries.reduce<Record<number, CartContestant>>((carry, entry) => {
            const contestant = contestantMap[entry.contestant_id];

            if (contestant) {
                carry[entry.contestant_id] = contestant;
            }

            return carry;
        }, {});

        if (removedCount > 0) {
            setEntries(validEntries);
            setCartNotice(buildRemovalMessage(removedCount, removedStatuses));
        }
    } finally {
        isCartReady.value = true;
    }
};

watch(
    entries,
    (nextEntries, previousEntries) => {
        persistEntries(nextEntries);
        const previousCount = previousEntries?.length ?? 0;

        if (
            nextEntries.length > previousCount
            && previousCount > 0
            && cartNotice.value
        ) {
            clearCartNotice();
        }

        void refreshCart();
    },
    { deep: true, immediate: true },
);

const cartItems = computed(() => {
    return entries.value.flatMap((entry) => {
        const contestant = contestantDetails.value[entry.contestant_id];

        if (!contestant) {
            return [];
        }

        return [
            {
                contestant_id: entry.contestant_id,
                votes: entry.votes,
                totalCost: entry.votes * COST_PER_VOTE,
                contestant: {
                    id: contestant.id,
                    slug: contestant.slug,
                    name: contestant.name,
                    image: contestant.image,
                    contestName: contestant.contest_name,
                },
            },
        ];
    });
});

const totalVotes = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + item.votes, 0);
});

const finalTotal = computed(() => totalVotes.value * COST_PER_VOTE);

const resolveContestId = (contestantId: number, contestant?: AddableContestant | null) => {
    const explicitContestId = contestant?.contestId;

    if (typeof explicitContestId === 'number' && explicitContestId > 0) {
        return explicitContestId;
    }

    const detailContestId = contestantDetails.value[contestantId]?.contest_id;

    if (typeof detailContestId === 'number' && detailContestId > 0) {
        return detailContestId;
    }

    return null;
};

const getVotesInContest = (contestId: number | null, excludedContestantId?: number) => {
    return entries.value.reduce((sum, entry) => {
        if (entry.contestant_id === excludedContestantId) {
            return sum;
        }

        if (contestId === null) {
            return sum + entry.votes;
        }

        const detailContestId = contestantDetails.value[entry.contestant_id]?.contest_id ?? null;

        if (detailContestId === contestId) {
            return sum + entry.votes;
        }

        return sum;
    }, 0);
};

const getMaxVotesAllowed = (contestantId: number, contestant?: AddableContestant | null) => {
    const contestId = resolveContestId(contestantId, contestant);
    const votesAlreadyInCart = getVotesInContest(contestId, contestantId);

    return Math.max(0, MAX_VOTES_PER_CONTEST - votesAlreadyInCart);
};

const parseVoteInput = (votes: number) => {
    if (!Number.isFinite(votes)) {
        return 1;
    }

    return Math.max(1, Math.floor(votes));
};

const buildVoteLimitNotice = (remainingVotes: number) => {
    if (remainingVotes <= 0) {
        return 'You have reached the 50-vote cart limit for this contest.';
    }

    if (remainingVotes === 1) {
        return 'Only 1 more vote can be added for this contest in the cart.';
    }

    return `Only ${remainingVotes} more votes can be added for this contest in the cart.`;
};

const addVotes = (contestantId: number, votes = 1, contestant?: AddableContestant | null) => {
    const contestStatus = normalizeContestStatus(contestant?.contestStatus);

    if (contestant && contestStatus !== 'active') {
        setCartNotice(getContestStatusMessage(contestStatus) || 'This contestant is no longer available.');
        return false;
    }

    clearCartNotice();
    const normalizedVotes = parseVoteInput(votes);
    const existingEntry = entries.value.find((entry) => entry.contestant_id === contestantId);
    const maxVotesAllowed = getMaxVotesAllowed(contestantId, contestant);

    if (maxVotesAllowed <= 0) {
        setCartNotice(buildVoteLimitNotice(0));
        return false;
    }

    if (existingEntry) {
        const currentVotes = existingEntry.votes;
        const requestedVotes = currentVotes + normalizedVotes;
        const nextVotes = Math.min(requestedVotes, maxVotesAllowed);

        if (nextVotes === currentVotes) {
            setCartNotice(buildVoteLimitNotice(maxVotesAllowed - currentVotes));
            return false;
        }

        existingEntry.votes = nextVotes;

        if (nextVotes < requestedVotes) {
            setCartNotice(buildVoteLimitNotice(maxVotesAllowed - nextVotes));
        } else if (cartNotice.value.includes('vote')) {
            clearCartNotice();
        }

        return true;
    }

    const votesToAdd = Math.min(normalizedVotes, maxVotesAllowed);

    if (votesToAdd < normalizedVotes) {
        setCartNotice(buildVoteLimitNotice(maxVotesAllowed - votesToAdd));
    }

    setEntries([
        ...entries.value,
        {
            contestant_id: contestantId,
            votes: votesToAdd,
        },
    ]);

    return true;
};

const updateVotes = (contestantId: number, votes: number, contestant?: AddableContestant | null) => {
    const entry = entries.value.find((item) => item.contestant_id === contestantId);
    if (!entry) {
        return;
    }

    const normalizedVotes = parseVoteInput(votes);
    const maxVotesAllowed = getMaxVotesAllowed(contestantId, contestant);

    if (maxVotesAllowed <= 0) {
        setCartNotice(buildVoteLimitNotice(0));
        return;
    }

    entry.votes = Math.min(normalizedVotes, Math.max(1, maxVotesAllowed));

    if (entry.votes < normalizedVotes) {
        setCartNotice(buildVoteLimitNotice(maxVotesAllowed - entry.votes));
    } else if (cartNotice.value.includes('vote')) {
        clearCartNotice();
    }
};

const removeVotes = (contestantId: number) => {
    setEntries(entries.value.filter((entry) => entry.contestant_id !== contestantId));
};

const clearCart = () => {
    clearCartNotice();
    contestantDetails.value = {};
    isCartReady.value = true;
    setEntries([]);
};

export const useVoteCart = () => {
    return {
        cartItems,
        cartNotice,
        totalVotes,
        finalTotal,
        costPerVote: COST_PER_VOTE,
        isCartReady,
        formatCurrency,
        addVotes,
        updateVotes,
        getMaxVotesAllowed,
        maxVotesPerContest: MAX_VOTES_PER_CONTEST,
        removeVotes,
        clearCart,
        clearCartNotice,
        refreshCart,
    };
};
