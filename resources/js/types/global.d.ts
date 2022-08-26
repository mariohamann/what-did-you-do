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
    category: string;
    archived: boolean;
};

type DeletedAction = {
    id: number;
}

type Action = {
    id: number;
    user: User;
    description: string;
    archived_at: Date;
    created_at: Date;
    likes: {
        total: number;
        liked: boolean;
    };
    category_id: Category['id'];
    inspirations: {
        total: number;
    };
    ancestors?: Action[] | DeletedAction[];
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
