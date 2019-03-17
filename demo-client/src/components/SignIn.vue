<template>
  <div class="row">
    <div class="col-12">
      <form class="p-3 mt-5 align-center" id="loginForm">
        <div class="form-group">
          <label for="exampleInputEmail1">Email address</label>
          <input
            type="email"
            class="form-control"
            id="exampleInputEmail1"
            aria-describedby="emailHelp"
            placeholder="Enter email"
            v-model="user.email"
          >
        </div>
        <div class="form-group">
          <label for="exampleInputPassword1">Password</label>
          <input
            type="password"
            class="form-control"
            id="exampleInputPassword1"
            placeholder="Password"
            v-model="user.password"
          >
        </div>
        <button type="submit" @click.prevent="login()" class="btn btn-primary">Sign In</button>
      </form>
    </div>
  </div>
</template>

<script>

export default {
  name: "signin",
  data() {
    return {
      user: {
        email: "",
        password: ""
      }
    };
  },
  beforeCreate(){
      let token = this.$session.get('accessToken');
      if (token != null) {
          this.$router.push('/product');
      }
  },

  methods:{
      login(){
          let newUser = {
              email : this.user.email,
              password: this.user.password
          };

        axios.post('/login', newUser)
        .then(res => {
            this.$session.set('accessToken', res.data.auth.access_token);
            localStorage.setItem('accessToken', res.data.auth.access_token);
            localStorage.setItem('user', res.data.user.email);

            window.isAuthenticated = true;

            this.$router.push('/product');
        })
      }
  },
  mounted(){
      console.log(this.$session.get('accessToken'));
  }
};
</script>

<style>
#loginForm {
  width: 50%;
  margin: auto;
}
</style>
