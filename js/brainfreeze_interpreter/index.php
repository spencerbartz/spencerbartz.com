<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Spencer's BrainFreeze Interpreter</title>

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <script type="text/javascript" src="resources/jquery-1.11.2.min.js"></script>
    <script type="text/javascript" src="resources/script.js"></script>
</head>

<body>

    <!--## Header (the top bar of the page) -->
    <div id="header">
        <div id="header-container">
            <!--## Logo image Pod -->
            <div id="logo">
                <img class="rounded" src="resources/logo.png" />
            </div>
        </div>
    </div>

    <!-- Main Content (lower part of page) -->
    <div id="main-content">
        
        <!-- Instructions -->
        <div id="instructions" class="rounded">
            <h3><?php echo _("What is BrainFreeze?"); ?></h3>
            <p>
                <div id="description">
                BrainFreeze is a programming language that consists of merely 8 characters: { [ ] > < . , + - } but can be used to create an infinite number programs.<br/><br/>
                The input area on the left receives normal text and converts into brain freeze. The input area on the right converts regular text back to BrainFreeze.<br/><br/>
                BrainFreeze is an exact clone of <a href="https://en.wikipedia.org/wiki/Brainfuck">this programming language</a>.
                However, this is a professional portfolio so I renamed it. Technically BrainFreeze is a subset of its parent language since it does not support input.
                It will be added in the next iteration to make BrainFreeze a truly Turing-Complete language. Refer to the <a href="https://en.wikipedia.org/wiki/Brainfuck">wikipedia page</a> for instructions on usage.
                If you need to debug a BrainFreeze program, use the # character and open JavaScript console.
                </div>
            </p>
        </div>    

        <!-- Ascii To Brainfuck converter Div-->
        <div id="converter" class="rounded">
            <h3><?php echo _("Text to BrainFreeze Converter"); ?></h3>
            <p>
            <textarea id="conv_input" class="rounded" placeholder="Type a message in plain text then press the Convert button to see the resulting BrainFreeze code below."></textarea>
            <input id="submit_conv_input" type="submit" class="rounded" value="Convert to BrainFreeze Code" onclick="BFI.asciiToBF('conv_input')" />
            </p>
            <p>
            <textarea id="conv_output" class="rounded"></textarea>
            <input id="clear_conv_output" type="submit" class="rounded" value="Clear" onclick="clearTextArea('conv_output')"/>
            </p>
        </div>    
        
        <!-- Interpreter Div-->
        <div id="interpreter" class="rounded">
            <h3><?php echo _("BrainFreeze to text Interpreter"); ?></h3>
            <p>
            <textarea id="intrp_input" class="rounded" placeholder="Enter raw BrainFreeze code here and you can decipher any BrainFreeze source code."></textarea>
            <input id="submit_intrp_input" type="submit" class="rounded" value="Interpret BrainFreeze Code" onclick="BFI.interpret('intrp_input')" />
            </p>
            <p>
            <textarea id="intrp_output" class="rounded"></textarea>
            <input id="clear_intrp_output" type="submit" class="rounded" value="Clear" onclick="clearTextArea('intrp_output');"/>
            </p>
        </div>    
    </div>
    
    <script type="text/javascript">
        BFI.initialize(30000, 'intrp_output', 'conv_output');
    </script>
    
    <div class="footer">
        <p>&copy;Spencer Bartz <?php print(gmdate("Y")); ?></p>
        <p><a href="http://www.spencerbartz.com">Return to main site</a></p>
    </div>

</body>
</html>