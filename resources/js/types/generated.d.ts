export type ActionData = {
    id: number;
    user: UserData;
    description: string;
    created_at: string;
    likes: ActionLikesData;
    category: CategoryData;
    descendants_count: number;
    ancestors: Array<ActionData>;
};
export type ActionIndexData = {
    actions: Array<ActionData>;
};
export type ActionLikesData = {
    total: number;
    liked: boolean;
};
export type CategoryData = {
    id: number;
    name: string;
    emoji: string;
    slug: string;
};
export type UserData = {
    id: number;
    name: string;
};
export type WelcomeData = {
    canLogin: boolean;
    canRegister: boolean;
    laravelVersion: string;
    phpVersion: string;
};
