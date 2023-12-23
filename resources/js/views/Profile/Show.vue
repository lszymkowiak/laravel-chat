<template>
    <Head title="Profile" />

    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Profile
            </h2>
        </div>
    </header>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div v-if="$page.props.jetstream.canUpdateProfileInformation">
                <UpdateProfileInformationForm :user="$page.props.auth.user" />

                <SectionBorder />
            </div>

            <div v-if="$page.props.jetstream.canUpdatePassword">
                <UpdatePasswordForm class="mt-10 sm:mt-0" />

                <SectionBorder />
            </div>

            <div v-if="$page.props.jetstream.canManageTwoFactorAuthentication">
                <TwoFactorAuthenticationForm
                    :requires-confirmation="confirmsTwoFactorAuthentication"
                    class="mt-10 sm:mt-0"
                />

                <SectionBorder />
            </div>

            <LogoutOtherBrowserSessionsForm :sessions="sessions" class="mt-10 sm:mt-0" />

            <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
                <SectionBorder />

                <DeleteUserForm class="mt-10 sm:mt-0" />
            </template>
        </div>
    </div>
</template>

<script setup>
import DeleteUserForm from '@/views/Profile/Partials/DeleteUserForm.vue';
import LogoutOtherBrowserSessionsForm from '@/views/Profile/Partials/LogoutOtherBrowserSessionsForm.vue';
import SectionBorder from '@/components/SectionBorder.vue';
import TwoFactorAuthenticationForm from '@/views/Profile/Partials/TwoFactorAuthenticationForm.vue';
import UpdatePasswordForm from '@/views/Profile/Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from '@/views/Profile/Partials/UpdateProfileInformationForm.vue';
import {Head} from "@inertiajs/vue3";

defineProps({
    confirmsTwoFactorAuthentication: {
        type: Boolean,
        default: false
    },
    sessions: {
        type: Array,
        default: () => []
    },
});
</script>
