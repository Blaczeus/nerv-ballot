export type ContestStatus = 'active' | 'upcoming' | 'ended';

export const normalizeContestStatus = (status?: string | null): ContestStatus | null => {
    const normalizedStatus = status?.trim().toLowerCase();

    if (normalizedStatus === 'active' || normalizedStatus === 'upcoming' || normalizedStatus === 'ended') {
        return normalizedStatus;
    }

    return null;
};

export const isVotingOpen = (status?: string | null) => normalizeContestStatus(status) === 'active';

export const getContestStatusLabel = (status?: string | null) => {
    switch (normalizeContestStatus(status)) {
        case 'active':
            return 'Voting Open';
        case 'upcoming':
            return 'Voting Not Started';
        case 'ended':
        default:
            return 'Voting Closed';
    }
};

export const getContestStatusMessage = (status?: string | null) => {
    switch (normalizeContestStatus(status)) {
        case 'upcoming':
            return 'Voting has not started yet';
        case 'ended':
            return 'Voting has ended';
        case 'active':
            return '';
        default:
            return 'This contestant is no longer available';
    }
};
