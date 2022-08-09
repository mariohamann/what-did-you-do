type Category = {
    id: number;
    name: string;
    emoji: string;
    slug: string;
};

type User = {
    id: number;
    name: string;
};

type Filters = {
    search: string;
    category: number;
};

type Action = {
    id: number;
    user: User;
    description: string;
    likes: {
        total: number;
        liked: boolean;
    };
    category_id: Category['id'];
};

type LaravelListProps = {
    filters: Filters;
    me: boolean;
    categories: Category[];
    title: string;
    user: {
        id: number;
        name: string;
    };
    actions: {
        current_page: number;
        links: { active: boolean; url: string; label: string; }[];
        data: Action[];
        first_page_url: string;
        from: number;
        last_page: number;
        last_page_url: string;
        next_page_url: string | null;
        prev_page_url: string | null;
        per_page: number;
        to: number;
        total: number;
    };
};
