import { createWebHistory, createRouter } from "vue-router";
import MyIndex from "@/Page/MyIndex";
import MyCreateNote from "@/Page/MyCreateNote";
import MyLogin from "@/Page/MyLogin";
import MyRegister from "@/Page/MyRegister";
import { ifAuth, ifNotAuth } from "./middleware/auth";

const routes = [
    {
        path: "/login",
        name: "login",
        component: MyLogin, 
        props:true,
        beforeEnter: ifAuth,
    },
    {
        path: "/register",
        name: "register",
        component: MyRegister,
        props:true,
        beforeEnter: ifAuth,
    },

    // For authenticated
    {
        path: "/",
        name: "index",
        component: MyIndex,
        props:true,
        beforeEnter: ifNotAuth,
    },
    {
        path: "/note/create",
        name: "create-note",
        component: MyCreateNote,
        props:true,
        beforeEnter: ifNotAuth,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router; 