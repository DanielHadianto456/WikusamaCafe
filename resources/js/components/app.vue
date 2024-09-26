<template>
    <!-- <h1>
        Hello App!
    </h1> -->
    <!-- <nav>
        <div>
            <router-link to="/">Home</router-link>
            <router-link to="/about">About</router-link>         
        </div>
    </nav> -->
    keren

     <p v-if="logins">{{logins.user}}</p> 
    <main>
        <router-view/>
    </main>
</template>

<script setup>

import { RouterLink, RouterView } from "vue-router";
import { useLogin } from "@/stores/auth";

const logins = useLogin()

</script>