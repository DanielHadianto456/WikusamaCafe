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
    <!-- keren-->
     <!-- <p v-if="logins">{{logins.role}}</p>   -->

    <main>
        <router-view/>
    </main>
</template>

<script>

// import { RouterLink, RouterView } from "vue-router";
// import { useLogin } from "@/stores/auth";

// const logins = useLogin()

export default{

    name: "App",

    // created(){

    //     let role = localStorage.getItem('role')

    //     if(role == "ADMIN"){

    //         this.$router.push({name: 'admin'})

    //     } else if(role == "MANAJER"){

    //         this.$router.push({name: 'manajer'})

    //     } else if(role == "KASIR"){

    //         this.$router.push({name: 'kasir'})

    //     } else {

    //         this.$router.push({name: 'login'})

    //     }

    // }

}

</script>