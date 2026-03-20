export type Testimonial = {
    id: number;
    title: string;
    quote: string;
    author: string;
    rating: number;
};

const testimonialRecords: Testimonial[] = [
    {
        id: 1,
        title: 'Clear and Trustworthy',
        quote: 'The voting process was smooth and easy to follow.',
        author: 'Sybil Sharp',
        rating: 5,
    },
    {
        id: 2,
        title: 'Smooth Experience',
        quote: 'I liked how I could track rankings in real time.',
        author: 'Mark G.',
        rating: 5,
    },
    {
        id: 3,
        title: 'Engaging Community',
        quote: 'Simple, clean, and actually fun to use.',
        author: 'Emily S.',
        rating: 5,
    },
    {
        id: 4,
        title: 'Confident Voting',
        quote: 'Everything felt clear, and the experience made supporting contestants easy.',
        author: 'Tolu A.',
        rating: 5,
    },
];

export const testimonials = testimonialRecords;

export const getTestimonials = async (): Promise<Testimonial[]> => {
    return testimonialRecords.map((testimonial) => ({ ...testimonial }));
};
