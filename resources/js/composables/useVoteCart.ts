import { computed, ref, watch } from 'vue';
import { COST_PER_VOTE } from '@/config/voting';

type StoredVoteCartEntry = {
    contestant_id: number;
    votes: number;
};

type CartContestant = {
    id: number;
    name: string;
    slug: string;
    image: string | null;
    total_votes: number;
    contest_id: number;
    contest_name: string | null;
};

const STORAGE_KEY = 'vote_cart';
const FALLBACK_IMAGE = '/tmp/images/products/womens/women-19.jpg';

const loadEntries = (): StoredVoteCartEntry[] => {
    if (typeof window === 'undefined') {
        return [];
    }

    try {
        const storedValue = window.localStorage.getItem(STORAGE_KEY);
        if (!storedValue) return [];

        const parsedValue = JSON.parse(storedValue);
        if (!Array.isArray(parsedValue)) return [];

        return parsedValue
            .map((entry) => ({
                contestant_id: Number(entry?.contestant_id),
                votes: Number(entry?.votes),
            }))
            .filter((entry) => Number.isInteger(entry.contestant_id) && entry.contestant_id > 0)
            .map((entry) => ({
                contestant_id: entry.contestant_id,
                votes: Math.max(1, Number.isFinite(entry.votes) ? entry.votes : 1),
            }));
    } catch {
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

const syncEntriesToStorage = (nextEntries: StoredVoteCartEntry[]) => {
    if (typeof window === 'undefined') {
        return;
    }

    window.localStorage.setItem(STORAGE_KEY, JSON.stringify(nextEntries));
};

const fetchContestantDetails = async (contestantIds: number[]) => {
    if (!contestantIds.length) {
        contestantDetails.value = {};
        return;
    }

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

    contestantDetails.value = (payload.contestants ?? []).reduce<Record<number, CartContestant>>(
        (carry, contestant) => {
            carry[contestant.id] = contestant;
            return carry;
        },
        {},
    );
};

watch(
    entries,
    (nextEntries) => {
        syncEntriesToStorage(nextEntries);
        void fetchContestantDetails(nextEntries.map((entry) => entry.contestant_id));
    },
    { deep: true, immediate: true },
);

const cartItems = computed(() => {
    return entries.value.map((entry) => {
        const contestant = contestantDetails.value[entry.contestant_id];

        return {
            contestant_id: entry.contestant_id,
            votes: entry.votes,
            totalCost: entry.votes * COST_PER_VOTE,
            contestant: {
                id: contestant?.id ?? entry.contestant_id,
                slug: contestant?.slug ?? '',
                name: contestant?.name ?? 'Loading contestant...',
                image: contestant?.image ?? FALLBACK_IMAGE,
                contestName: contestant?.contest_name ?? 'Contest',
                votes: contestant?.total_votes ?? 0,
            },
        };
    });
});

const totalVotes = computed(() => {
    return entries.value.reduce((sum, item) => sum + item.votes, 0);
});

const finalTotal = computed(() => totalVotes.value * COST_PER_VOTE);

const addVotes = (contestantId: number, votes = 1) => {
    const normalizedVotes = Math.max(1, votes);
    const existingEntry = entries.value.find((entry) => entry.contestant_id === contestantId);

    if (existingEntry) {
        existingEntry.votes += normalizedVotes;
        return;
    }

    entries.value = [
        ...entries.value,
        {
            contestant_id: contestantId,
            votes: normalizedVotes,
        },
    ];
};

const updateVotes = (contestantId: number, votes: number) => {
    const entry = entries.value.find((item) => item.contestant_id === contestantId);
    if (!entry) return;

    entry.votes = Math.max(1, votes);
};

const removeVotes = (contestantId: number) => {
    entries.value = entries.value.filter((entry) => entry.contestant_id !== contestantId);
};

const clearCart = () => {
    entries.value = [];
};

export const useVoteCart = () => {
    return {
        cartItems,
        totalVotes,
        finalTotal,
        costPerVote: COST_PER_VOTE,
        formatCurrency,
        addVotes,
        updateVotes,
        removeVotes,
        clearCart,
    };
};
