<template>
    <div class="card">
        <div class="card-header text-secondary">
            <fa-icon :icon="['fa','plus-circle']" @click="createChat" class="icons" size="1x"/>
            <p class="lead">Create new chat ...</p>
        </div>
        <div class="card-body">
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

            
            <div class="chat">
                <img  :src="require('../../assets/user.png')"  alt="">
                <div class="content">
                    <p><strong> Ivan Ivanov </strong></p>
                    <small>dfghjkl;</small>
                </div>
                <div class="notification float-right">
                    <fa-icon :icon="['fa', 'pen']" class="icons" />
                    <span class="badge badge-primary">10</span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>


export default {
    name: 'inex-chat',
    methods: {
        createChat() {
            this.$router.push('/chat/create');
        }
    }
}
</script>

<style scoped>
.card {
    height: 630px;
}
.card-header {
    display: flex;
    padding: 0px 12px;
}
.card-body {
    padding: 10px;
}
.icons {
    margin: 8px;
}
.lead {
    margin: 0;
}
.chat {
    border: solid 1px rgba(0, 0, 0, 0.125);
    display: flex;
    margin: 5px 0px;
}
.notification {
    display: flex;
    flex-direction: column;
    margin-left: 135px;
}
img {
    border-radius: 50%;
    width: 60px;
    padding: 5px;
    margin: 2px;
}
p {
    margin: 0px;
};
</style>

