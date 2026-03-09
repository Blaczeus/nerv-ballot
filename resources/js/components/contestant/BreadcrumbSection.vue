<script setup lang="ts">
import { Link } from '@inertiajs/vue3';

defineOptions({ inheritAttrs: false });

const props = defineProps<{
    contestantName: string;
}>();
</script>

<template>
    <!-- breadcrumb -->
    <div class="tf-breadcrumb">
        <div class="container">
            <div class="tf-breadcrumb-wrap">
                <div class="tf-breadcrumb-list">
                    <Link href="/" class="text text-caption-1">Homepage</Link>
                    <i class="icon icon-arrRight"></i>
                    <Link href="/contestants" class="text text-caption-1">Contestants</Link>
                    <i class="icon icon-arrRight"></i>
                    <span class="text text-caption-1">{{ props.contestantName }}</span>
                </div>
                <div class="tf-breadcrumb-prev-next">
                    <Link href="/contestants" class="tf-breadcrumb-prev">
                        <i class="icon icon-arrLeft"></i>
                    </Link>
                    <Link href="/contestants" class="tf-breadcrumb-back">
                        <i class="icon icon-squares-four"></i>
                    </Link>
                    <Link href="/contestants" class="tf-breadcrumb-next">
                        <i class="icon icon-arrRight"></i>
                    </Link>
                </div>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->
</template>
