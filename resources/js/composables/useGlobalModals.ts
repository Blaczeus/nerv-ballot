import { reactive } from 'vue';

export type ModalContestant = {
    id: number;
    slug: string;
    name: string;
    image: string;
    hoverImage: string;
    price: string;
    oldPrice?: string;
    description: string;
    availability: string;
    brand: string;
};

type BootstrapLike = {
    Modal?: {
        getOrCreateInstance: (element: Element) => { show: () => void };
    };
    Offcanvas?: {
        getOrCreateInstance: (element: Element) => { show: () => void };
    };
};

const state = reactive<{
    contestant: ModalContestant | null;
}>({
    contestant: null,
});

const showBootstrapModal = (id: string) => {
    const element = document.getElementById(id);
    if (!element) return;

    const bootstrap = (window as unknown as { bootstrap?: BootstrapLike }).bootstrap;
    if (bootstrap?.Modal) {
        bootstrap.Modal.getOrCreateInstance(element).show();
        return;
    }

    const jq = (window as unknown as { jQuery?: (selector: string) => { modal: (arg: string) => void } }).jQuery;
    jq?.(`#${id}`)?.modal?.('show');
};

const showBootstrapOffcanvas = (id: string) => {
    const element = document.getElementById(id);
    if (!element) return;

    const bootstrap = (window as unknown as { bootstrap?: BootstrapLike }).bootstrap;
    if (bootstrap?.Offcanvas) {
        bootstrap.Offcanvas.getOrCreateInstance(element).show();
        return;
    }

    const jq = (window as unknown as { jQuery?: (selector: string) => { offcanvas: (arg: string) => void } }).jQuery;
    jq?.(`#${id}`)?.offcanvas?.('show');
};

export const useGlobalModals = () => {
    const openQuickView = (contestant: ModalContestant) => {
        state.contestant = contestant;
        showBootstrapModal('quickView');
    };

    const openCart = (contestant: ModalContestant) => {
        state.contestant = contestant;
        showBootstrapModal('shoppingCart');
    };

    const openFilter = () => {
        showBootstrapOffcanvas('filterShop');
    };

    return {
        state,
        openQuickView,
        openCart,
        openFilter,
    };
};
