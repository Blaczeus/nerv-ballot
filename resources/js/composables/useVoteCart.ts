import { computed, ref } from 'vue';
import { COST_PER_VOTE } from '@/config/voting';
import { contestants } from '@/data/contestants';
import { voteCart } from '@/data/voteCart';

type VoteCartEntry = (typeof voteCart)[number];

const entries = ref<VoteCartEntry[]>(voteCart.map((entry) => ({ ...entry })));
const nextEntryId = ref(
    voteCart.reduce((highest, entry) => Math.max(highest, entry.id), 0) + 1,
);

const currencyFormatter = new Intl.NumberFormat('en-NG', {
    style: 'currency',
    currency: 'NGN',
    maximumFractionDigits: 0,
});

const formatCurrency = (amount: number) => currencyFormatter.format(amount);

const cartItems = computed(() => {
    return entries.value
        .map((entry) => {
            const contestant = contestants.find((item) => item.id === entry.contestantId);
            if (!contestant) return null;

            return {
                id: entry.id,
                contestant,
                votes: entry.votes,
                totalCost: entry.votes * COST_PER_VOTE,
            };
        })
        .filter((item): item is NonNullable<typeof item> => item !== null);
});

const totalVotes = computed(() => {
    return cartItems.value.reduce((sum, item) => sum + item.votes, 0);
});

const finalTotal = computed(() => totalVotes.value * COST_PER_VOTE);

const addVotes = (contestantId: number, votes = 1) => {
    const normalizedVotes = Math.max(1, votes);
    const existingEntry = entries.value.find((entry) => entry.contestantId === contestantId);

    if (existingEntry) {
        existingEntry.votes += normalizedVotes;
        return;
    }

    entries.value = [
        ...entries.value,
        {
            id: nextEntryId.value,
            contestantId,
            votes: normalizedVotes,
        },
    ];
    nextEntryId.value += 1;
};

const updateVotes = (entryId: number, votes: number) => {
    const entry = entries.value.find((item) => item.id === entryId);
    if (!entry) return;

    entry.votes = Math.max(1, votes);
};

const removeVotes = (entryId: number) => {
    entries.value = entries.value.filter((entry) => entry.id !== entryId);
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
    };
};
