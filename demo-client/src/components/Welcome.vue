<template>
  <div class="row">
    <div class="col-12" id="welcomePage">
      <h1 class="mt-5">Welcome {{heading}}</h1>
    </div>
  </div>
</template>
<script>
export default {
  name: "welcome",
  data(){
      return{
          heading: "To Demo Store"
      }
  }
};
</script>
<style>
#welcomePage {
  height: 100%;
  width: 100%;
  margin: auto;
}

#welcomePage h1{
  width: fit-content;
  margin: auto;
}
</style>
