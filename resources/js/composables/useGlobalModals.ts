import { reactive } from 'vue';
import type { ContestStatus } from '@/utils/contestStatus';

export type ModalContestant = {
    id: number;
    contestId?: number | null;
    slug: string;
    name: string;
    contestName: string;
    contestStatus: ContestStatus | null;
    category: string;
    location: string;
    gender: string;
    votes: number;
    contestStart: string;
    contestEnd: string;
    createdAt: string;
    image: string;
    hoverImage: string;
    description: string;
};

export type FrontendModalName =
    | 'search'
    | 'quickView'
    | 'cart'
    | 'filter'
    | 'share'
    | 'askQuestion'
    | null;

const state = reactive<{
    activeModal: FrontendModalName;
    contestant: ModalContestant | null;
}>({
    activeModal: null,
    contestant: null,
});

export const useGlobalModals = () => {
    const openQuickView = (contestant: ModalContestant) => {
        state.contestant = contestant;
        state.activeModal = 'quickView';
    };

    const openSearch = () => {
        state.activeModal = 'search';
    };

    const openCart = (contestant?: ModalContestant | null) => {
        if (contestant) {
            state.contestant = contestant;
        }
        state.activeModal = 'cart';
    };

    const openFilter = () => {
        state.activeModal = 'filter';
    };

    const openShare = (contestant?: ModalContestant | null) => {
        if (contestant) {
            state.contestant = contestant;
        }
        state.activeModal = 'share';
    };

    const openAskQuestion = () => {
        state.activeModal = 'askQuestion';
    };

    const closeModal = (modalName?: Exclude<FrontendModalName, null>) => {
        if (!modalName || state.activeModal === modalName) {
            state.activeModal = null;
        }
    };

    const closeAllModals = () => {
        state.activeModal = null;
    };

    return {
        state,
        openSearch,
        openQuickView,
        openCart,
        openFilter,
        openShare,
        openAskQuestion,
        closeModal,
        closeAllModals,
    };
};
