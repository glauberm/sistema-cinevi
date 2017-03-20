$(".input-number, .input-tel").on("input paste", function() {
    this.value = this.value.replace(/[^\d\.\-]/g,'');
});
$(".input-number").siblings("label").after("<small class='text-muted'> (somente números)</small>");
$(".input-tel").siblings("label").after("<small class='text-muted'> (somente números, com DDD)</small>");
