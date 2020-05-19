<template>
    <div class="card">
        <div class="card-header text-secondary">
            <p><strong>Ivan Ivanov</strong></p>
            <small>last seen 3 minutes ago</small>
            <div class="float-right">
                <fa-icon :icon="['fa', 'pen']" class="icons" />
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-primary float-right" role="alert">
                This is a primary alert—check it out!
            </div>
            <div class="alert alert-info float-left" role="alert">
            This is a info alert—check it out!
            </div>
        </div>
        <div class="card-footer">

        </div>
    </div>
</template>

<script>
export default {
    name: 'index-message'
    
}
</script>

<style scoped>
.card-header {
    padding: 10px 20px;
}
p {
    margin: 0px;
}
.card-body {
    height: 510px;
}
.card-footer {
    height: 50px;
}
</style>