<style>
    footer {
        position: absolute;
        left: 0;
        bottom: 0;
        width: calc(100% - 40px);
        background-color: rgb(228, 228, 228);
        color: white;
        padding: 10px 0;
        font-family: 'Arial', sans-serif;
        text-align: center;
    }

    .site-footer {
        padding: 0px 20px;
    }

    .footer-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .authors {
        text-align: left;
        flex: 1;
    }

    .authors ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: center;
    }

    .authors li {
        margin-bottom: 0;
    }

    .authors a {
        color: rgb(46, 42, 33);
        text-decoration: none;
        font-weight: 600;
        font-size: 1rem;
    }

    .authors a:hover {
        text-decoration: underline;
    }

    .disclaimer {
        font-size: 1rem;
        margin-top: 10px;
        color: rgb(68, 61, 61);
        flex: 1;
        text-align: right;
    }

    .disclaimer p {
        font-style: italic;
        font-weight: 300;
        margin: 0;
    }
</style>

<footer class="site-footer">
    <div class="footer-content">
        <div class="authors">
            <ul>
                <li><a href="https://github.com/hiibolt" target="_blank">John W - @hiibolt</a></li>
                <li><a href="https://github.com/shaivilp" target="_blank">Shavil P - @shaivilp</a></li>
                <li><a href="https://github.com/reybozo" target="_blank">Alex R - @reybozo</a></li>
                <li><a href="https://github.com/ibarra617" target="_blank">Antonio I - @ibarra617</a></li>
            </ul>
        </div>

        <div class="disclaimer">
            <p>Disclaimer: Spells are only partially sourced from dark wizards.<br>The rest? A dash of good old-fashioned magic :3</p>
        </div>
    </div>
</footer>
