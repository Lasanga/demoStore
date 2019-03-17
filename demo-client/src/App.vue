<template>
  <div id="app">
    <app-header isLogged='true'/>
    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import AppHeader from "./components/AppHeader.vue";

export default {
  name: "app",
  components: {
    AppHeader
  }
};
</script>

