<template>
  <div class="mt-3">
    <h4>Question</h4>
    <p>{{question}}</p>
    <hr>
    <div class="mt3">
      <h4>Answer</h4>
      <strong>{{answer}}</strong>
      <br>
      <i>{{justify}}</i>
    </div>
  </div>
</template>
<script>
export default {
  name: "logic",
  data() {
    return {
      question:
        "In the courtyard of a house there are three large cages painted in different colors: red, yellow and green. In the cages live rabbits. In the green cage there are 2 times more rabbits than in the yellow one. One day from the cage on the left they take out 5 rabbits to let them out for a while, and half of the remaining rabbits are moved to the red cage. What color was the cage on the left?",
      answer: "Yellow cage",
      justify:
        "Green cage is double the quantity of yellow cage which means it is an even number. It is mentioned that 5 rabbits were taken from left cage. Then half of the rabbits were moved to red cage. Prooved that once 5 rabbits were taken out only it became an even number in left cage. Therefore answer cannot be green cage neither red cage."
    };
  }
};
</script>
