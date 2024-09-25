<template>
  <div class="wrapper">
    <div class="form-wrapper">
      <form @submit.prevent="console.log(formData)" method="POST">
        <table class="form-table" border="0" cellpadding="10">
          <tr class="form-column">
            <td class="form-row">
              <h1>Register</h1>
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <input
                class="name-input"
                type="text"
                placeholder="Name"
                name="name"
                required
                v-model="formData.name"
              />
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <input
                class="username-input"
                type="text"
                placeholder="Username"
                name="username"
                required
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
                name="password"
                required
                v-model="formData.password"
              />
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <select  
              name="role" 
              placeholder="Role" 
              required
              v-model="formData.role"
              >
                <option value="ADMIN">Admin</option>
                <option value="MANAJER">Manajer</option>
                <option value="KASIR">Kasir</option>
              </select>
            </td>
          </tr>
          <tr class="form-column">
            <td class="form-row">
              <button type="submit">Register</button>
            </td>
          </tr>
          <tr>
            <td></td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from "vue";


const formData = reactive({
  name: "",
  username: "",
  password: "",
  role: "",
});

</script>

<style scoped>
.wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #e3e9c2;
}

.form-table {
  justify-content: center;
  border-collapse: collapse;
  width: 50vh;
  height: 50vh; /* Increased height */
  background-color: white;
  text-align: center;
  box-shadow: 5px 7.5px rgba(136, 136, 136, 0.5);
}

.form-table td {
  padding: 2vh; /* Adjusted padding to maintain row distance */
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

.wrapper .form-table select {
  border: 0;
  outline: none;
  border-bottom: 2px solid;
  position: relative;
  width: 100%;
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
