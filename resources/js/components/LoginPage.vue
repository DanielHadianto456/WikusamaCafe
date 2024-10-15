<template>
  <div class="wrapper">
    <div class="form-wrapper">
      <form @submit.prevent="authenticate('auth/login', formData)" method="POST">
        <table class="form-table" border="0" cellpadding="10">
          <tr class="form-column">
            <td class="form-row">
              {{ token }}
              <h1>Login</h1>
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <input
                class="username-input"
                type="text"
                placeholder="Username"
                v-model="formData.username"
              />
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <input
                class="password-input"
                type="password"
                placeholder="Password"
                v-model="formData.password"
              />
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <button type="submit">Login</button>
            </td>
          </tr>
          <!-- <tr class="form-column">
            <td class="form-row">
              <p>
                Don't have an account? <router-link to="/register">Register</router-link>
              </p>
            </td>
          </tr> -->
          <tr>
            <td></td>
          </tr>
          <!-- <span></span> -->
        </table>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from "vue";
import { useLogin } from "@/stores/auth";
import { useRouter } from "vue-router";

const token = ref(localStorage.getItem("token"));
const router = useRouter();

const { authenticate } = useLogin();

const formData = reactive({
  username: "",
  password: "",
});

onMounted(() => {
  if(token.value){
    router.push({name: 'home'});
  }
});

</script>


<style scoped>
.wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  /* background-color: #e3e9c2; */
}

.form-table {
  justify-content: center;
  border-collapse: collapse;
  width: 50vh;
  height: 50vh; /* Increased height */
  background-color: white;
  text-align: center;
  box-shadow: 5px 7.5px rgba(53, 53, 53, 0.5);
}

.form-table td {
  padding: 2vh;
  border-bottom: 0px; /* Adjusted padding to maintain row distance */
}

.wrapper .form-table input {
  border: 0;
  outline: none;
  border-bottom: 2px solid;
  position: relative;
  width: 50vh;
  height: 7.5vh;
  padding: 1vh 2vh;
  font-size: 2vh;
}

.form-table .form-column .form-row h1 {
  position: relative;
  top: 2vh;
  font-family: "Poppins";
  font-size: 5vh;
}

.form-table .form-column .form-row button {
  position: relative;
  /* bottom: 1vh; */
  width: 50vh;
  height: 7.5vh;
  cursor: pointer;
  background-color: #071013;
  border: none;
  color: white;
  border-radius: 5vh;
  font-size: 2vh;
}

.form-table .form-column .form-row p {
  font-family: "poppins";
  font-size: 2vh;
}
</style>
