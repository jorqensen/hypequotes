<html>
    <head>
        <title>Rymercy quotes</title>

        <link rel="stylesheet" href="https://the.missing.style">
        <script src="https://unpkg.com/htmx.org@1.7.0"></script>
        <script src="https://unpkg.com/hyperscript.org@0.9.5"></script>
    </head>
    <body>
        <main>
            <h1>hyperscript is the future and poggers</h1>
            <div script="install TabContainer">

                <div role="tablist">
                    <button role="tab" id="tab-1" aria-controls="panel-1" aria-selected="true">View quotes</button>
                </div>
        
                <div role="tabpanel" id="panel-1" aria-labelledby="tab-1">
                    <div id="quotes">

                    </div>
                    <button _="on click show the next <progress/> then wait 5s then fetch ./quotes1.mark then put the result into the previous <div/> then wait 1s then hide the <progress/>">Load quotes</button>
                    <progress style="display: none;float:right;"></progress>
                </div>
                <div role="tabpanel" id="panel-2" aria-labelledby="tab-2" hidden=""><p>This is the content for the second tab</p></div>
                <div role="tabpanel" id="panel-3" aria-labelledby="tab-3" hidden=""><p>This is the content for the third tab</p></div>
            </div>
        </main>

        <template url="./quotes1.mark" delay="1000"></template>
    </body>
</html>