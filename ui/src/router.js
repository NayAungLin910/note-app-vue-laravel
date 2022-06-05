import { createWebHistory, createRouter } from "vue-router";
import MyIndex from "@/Page/MyIndex";
import MyCreateNote from "@/Page/MyCreateNote";
import MyLogin from "@/Page/MyLogin";
import MyRegister from "@/Page/MyRegister";
import MyCreateLabel from "@/Page/MyCreateLabel";
import MyContribute from "@/Page/MyContribute";
import MyViewContribute from "@/Page/MyViewContribute";
import MyProfile from "@/Page/MyProfile";
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
        path: "/profile",
        name: "profile",
        component: MyProfile,
        props:true,
        beforeEnter: ifNotAuth,
    },
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
    {
        path: "/label/create",
        name: "create-label",
        component: MyCreateLabel,
        props:true,
        beforeEnter: ifNotAuth,
    },
    {
        path: "/note/:slug",
        name: "note-detail",
        component: MyCreateNote,
        props:true,
        beforeEnter: ifNotAuth,
    },
    {
        path: "/note/label/:slug",
        name: "noteByLabel",
        component: MyIndex,
        props:true,
        beforeEnter: ifNotAuth,
    },
    {
        path: "/note/contribute/:slug",
        name: "contribute",
        component: MyContribute,
        props:true,
        beforeEnter: ifNotAuth,
    },
    {
        path: "/contribute/:option",
        name: "view-contribute",
        component: MyViewContribute,
        props:true,
        beforeEnter: ifNotAuth,
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router; 