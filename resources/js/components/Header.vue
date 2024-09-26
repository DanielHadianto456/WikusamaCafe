<!-- <template>
  <div class="nav">
    <div class="hero">
      <h1>WikusamaCafe Panel</h1>
    </div>
    <div></div>
    <div class="items" v-if="user">
      <router-link to="/login" class="item">Logout</router-link>
      <span class="item">Welcome, {{ user }}</span>
    </div>
    <div class="items" v-else>
        <span @click="authenticate('auth/logout')">Logout</span>
    </div>
  </div>
</template> -->

<template>
  <div class="nav">
    <div class="hero">
      <h1>WikusamaCafe Panel</h1>
    </div>
    <div></div>
    <div class="items" v-if="user">
      <span class="item">Welcome, {{ user }}</span>
      <span @click="logout" class="item">Logout</span>
    </div>
    <div class="items" v-else>
      <router-link to="/login" class="item">Login</router-link>
    </div>
  </div>
</template>

<script>
// import { useLogout } from "@/stores/auth";

// const { authenticate } = useLogout();

// export default {

    

//   name: "Header",

//   data() {

//     return {

//       user: localStorage.getItem('user'),

//     };

//   },

// };

import { useLogout } from "@/stores/auth";

export default {

  name: "Header",

  data() {

    return {

      user: localStorage.getItem('user'),

    };

  },

  methods: {

    logout() {

      const logoutStore = useLogout();

      logoutStore.authenticate('auth/logout')
        .then(() => {
          // Optionally handle any post-logout actions here
          this.user = null; // Clear the user data from the component
        })
        .catch((error) => {
          console.error("Logout error:", error);
        });

    },

  },

};
</script>

<style scoped>
.item,
.item:visited,
.item:hover,
.item:active {
  color: inherit;
  text-decoration: none;
}

.nav {
  background-color: #674636;
  /* height: vh; */
  padding: 3vh;
  display: flex;
  font-family: "poppins";
  justify-content: space-between;
  color: white;
}

.nav .hero h1 {
  font-size: 3vh;
}

.nav .items .item {
  font-size: 2.25vh;
  margin: 0 3vh;
  /* display: flex; */
  /* display: inline-block;
    justify-content: end; */
}
</style>

