<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <router-link :to="'/'" class="navbar-brand">DemoStore</router-link>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <!-- <li class="nav-item">
            <router-link :to="'/product'" class="nav-link active">Products</router-link>
          </li>-->
          <li class="nav-item">
            <router-link :to="'/sale'" class="nav-link active">Sales</router-link>
          </li>
          <li class="nav-item">
            <router-link :to="'/logic'" class="nav-link active">Logic</router-link>
          </li>
        </ul>
        <div class="form-inline navbar-nav my-2 my-lg-0">
          <router-link :to="'/signin'" class="nav-link active">Sign In</router-link>
          <router-link :to="'/signup'" class="nav-link active">Sign Up</router-link>
          <router-link :to="'/signout'" class="nav-link active">Sign Out</router-link>
        </div>
      </div>
    </div>
  </nav>
</template>
<script>
export default {
  name: "app-header",
  data() {
    return {
      isLogged: false
    };
  }
};
</script>
