<script setup lang="ts">
import { computed, ref } from 'vue';
import type { ModalContestant } from '@/composables/useGlobalModals';
import { formatVotes } from '@/utils/formatVotes';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    contestant: ModalContestant;
}>();

const formattedVotes = computed(() => formatVotes(props.contestant.votes));

const dateFormatter = new Intl.DateTimeFormat('en-US', {
    weekday: 'short',
    month: 'short',
    day: 'numeric',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
});

const formatDisplayDate = (value: string) => {
    if (!value) return 'TBD';

    const date = new Date(value); 
    if (Number.isNaN(date.getTime())) {
        return value;
    }

    return dateFormatter.format(date);
};

const contestDateRange = computed(() => {
    return `${formatDisplayDate(props.contestant.contestStart)} to ${formatDisplayDate(props.contestant.contestEnd)}`;
});

const joinedDate = computed(() => formatDisplayDate(props.contestant.createdAt));
const activeTab = ref(0);

const tabs = [
    { label: 'About Contestant' },
    { label: 'Contest Info' },
    { label: 'Voting Rules' },
];

const setTab = (index: number) => {
    activeTab.value = index;
};
</script>

<template>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="widget-tabs style-menu-tabs">
                        <ul class="widget-menu-tab">
                            <li v-for="(tab, index) in tabs" :key="tab.label" class="item-title"
                                :class="{ active: activeTab === index }" @click="setTab(index)">
                                <span class="inner">{{ tab.label }}</span>
                            </li>
                        </ul>
                        <div class="widget-content-tab">
                            <div v-show="activeTab === 0" class="widget-content-inner"
                                :class="{ active: activeTab === 0 }">
                                <div class="tab-description">
                                    <div class="right">
                                        <div class="letter-1 text-btn-uppercase mb_12">{{ contestant.name }}</div>
                                        <p class="mb_12 text-secondary">{{ contestant.description }}</p>
                                        <p class="text-secondary">
                                            This profile highlights the contestant's story, current standing, and the
                                            details voters need before confirming support.
                                        </p>
                                    </div>
                                    <div class="left">
                                        <div class="letter-1 text-btn-uppercase mb_12">PROFILE SNAPSHOT</div>
                                        <ul class="list-text type-disc mb_12 gap-6">
                                            <li class="font-2">Contest: {{ contestant.contestName }}</li>
                                            <li class="font-2">Category: {{ contestant.category }}</li>
                                            <li class="font-2">Location: {{ contestant.location }}</li>
                                            <li class="font-2">Current Votes: {{ formattedVotes }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 1" class="widget-content-inner"
                                :class="{ active: activeTab === 1 }">
                                <div class="tab-description">
                                    <div class="right">
                                        <div class="letter-1 text-btn-uppercase mb_12">CONTEST DETAILS</div>
                                        <p class="mb_12 text-secondary">
                                            {{ contestant.name }} is competing in {{ contestant.contestName }} in the
                                            {{ contestant.category.toLowerCase() }} category.
                                        </p>
                                        <p class="text-secondary">
                                            Voting for this contest runs from {{ contestDateRange }}.
                                        </p>
                                    </div>
                                    <div class="left">
                                        <div class="letter-1 text-btn-uppercase mb_12">OVERVIEW</div>
                                        <ul class="list-text type-disc mb_12 gap-6">
                                            <li class="font-2">Contestant ID: {{ contestant.id }}</li>
                                            <li class="font-2">Gender: {{ contestant.gender }}</li>
                                            <li class="font-2">Joined: {{ joinedDate }}</li>
                                            <li class="font-2">Location: {{ contestant.location }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div v-show="activeTab === 2" class="widget-content-inner"
                                :class="{ active: activeTab === 2 }">
                                <div class="tab-policies">
                                    <div class="text-btn-uppercase mb_12">Voting rules</div>
                                    <p class="mb_12 text-secondary">
                                        Review your selections carefully before completing payment.
                                    </p>
                                    <ul class="list-text type-number">
                                        <li class="text-secondary font-2">
                                            Select the number of votes you want to assign to this contestant.
                                        </li>
                                        <li class="text-secondary font-2">
                                            Added votes appear in your vote cart before final confirmation.
                                        </li>
                                        <li class="text-secondary font-2">
                                            Votes are recorded once payment is confirmed and cannot be reversed.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
