<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading" v-text="heading"></div>

                    <div class="panel-body" v-model="body">
                        {{ body }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                heading: 'Example Component',
                body: "I'm an example component!"
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
