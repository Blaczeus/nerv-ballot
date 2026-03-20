const voteFormatter = new Intl.NumberFormat('en-US');

export const formatVotes = (votes: number) => {
    if (typeof votes !== 'number' || Number.isNaN(votes)) {
        return '0 Votes';
    }

    return `${voteFormatter.format(votes)} Votes`;
};
