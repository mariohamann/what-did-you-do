type Category = {
    id: number;
    name: string;
    emoji: string;
};

type User = {
    id: number;
    name: string;
};

type Action = {
    id: number;
    user: User;
    description: string;
    category_id: Category['id'];
};
