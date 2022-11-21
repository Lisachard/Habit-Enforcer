<header>
    <h1 class="gradient-text">Error 404</h1>
</header>

<style>
    .gradient-text {
        background-color: #DC5B51;
        background-image: linear-gradient(45deg, #DC5B51 16.666%, #DFB79E 16.666%, #DFB79E 33.333%, #DC5B51 33.333%, #DC5B51 50%, #DFB79E 50%, #DFB79E 66.666%, #DC5B51 66.666%, #DC5B51 83.333%, #DFB79E 83.333%);
        background-size: 100%;
        background-repeat: repeat;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: text-animation-r 0.75s ease forwards;
    }

    .gradient-text:hover {
        animation: text-animation 0.5s ease-in forwards;
    }

    @keyframes text-animation-r {
        0% {
            background-size: 650%;
        }

        40% {
            background-size: 650%;
        }

        100% {
            background-size: 100%;
        }
    }

    @keyframes text-animation {
        0% {
            background-size: 100%;
        }

        80% {
            background-size: 650%;
        }

        100% {
            background-size: 650%;
        }
    }

    body {
        background-color: #45011A;
    }

    header {
        margin-top: 1em;
        margin-top: calc(50vh - 3em);
    }

    h1 {
        font-family: "Archivo Black", sans-serif;
        font-weight: normal;
        font-size: 6em;
        text-align: center;
        margin-bottom: -0.25em;
        display: block;
        margin-left: auto;
        margin-right: auto;
        cursor: pointer;
        width: 605px;
    }
</style>