<template>
  <Header />
  <div class="wrapper"></div>
</template>

<script>
import Header from "./Header.vue";

export default {
  components: {
    Header,
  },
  name: "Home",
};
</script>

<style scoped>
.wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #FFF8E8;
}
</style>
