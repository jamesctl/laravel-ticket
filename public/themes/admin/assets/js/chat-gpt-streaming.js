const API_URL = "https://api.openai.com/v1/chat/completions";
const API_KEY = $("#api_key").val();

const promptInput = $(".title-vi")[0];
const promptEnglisg = $('#promtEnglish').val();
const promptJapanese = $('#promtJapanese').val();
const btnGenerateTitle = $("#btn-generate-title")[0];
const btnGenerateShortDescription = $("#btn-generate-shortDesc")[0];
const btnGenerateDescription = $("#btn-generate-desc")[0];

let controller = null; // Store the AbortController instance

const generate = async (section) => {
    $(btnGenerateTitle).prop("disabled", true);
    $(btnGenerateShortDescription).prop("disabled", true);
    $(btnGenerateDescription).prop("disabled", true);

    // Create a new AbortController instance
    controller = new AbortController();
    const signal = controller.signal;

    switch (section) {
        case "title":
            // btnGenerateTitle.text("Generating...");
            generateContent(signal, promptEnglisg, $( promptInput).val(), "input", "title-vi", "title-en", "english");
            generateContent(signal, promptJapanese, $( promptInput).val(), "input", "title-vi", "title-ja", "japanese");
            // btnGenerateTitle.html("Translate this content with Chat GPT");
            break;
        case "short_description":
            // btnGenerateShortDescription.html("Generating...");
            generateContent(signal, promptEnglisg, tinymce.get("short_description-vi").getContent(), "editor", "short_description-vi", "short_description-en", "english");
            generateContent(signal, promptJapanese, tinymce.get("short_description-vi").getContent(), "editor", "short_description-vi", "short_description-ja", "japanese");
            // btnGenerateShortDescription.html("Translate this content with Chat GPT");
            break;
        case "description":
            // btnGenerateDescription.html("Generating...");
            generateContent(signal, promptEnglisg, tinymce.get("description-vi").getContent(), "editor", "description-vi", "description-en", "english");
            generateContent(signal, promptJapanese, tinymce.get("description-vi").getContent(), "editor", "description-vi", "description-ja", "japanese");
            // btnGenerateDescription.html("Translate this content with Chat GPT");
            break;
        default:
            break;
    }

    $(btnGenerateTitle).prop("disabled", false);
    $(btnGenerateShortDescription).prop("disabled", false);
    $(btnGenerateDescription).prop("disabled", false);
};

const generateContent = async (
    signal,
    prompt,
    input,
    outputType,
    inputId,
    outputId,
    toLanguage,
) => {
    try {
        if (input === "") {
            switch (inputId) {
                case "title-vi":
                    alert(`Can't create a translation for the ${toLanguage} title yet, please enter the title to generate.`);
                    break;
                case "short_description-vi":
                    alert(`Can't create a translation for the ${toLanguage} short description yet, please enter the short description to generate.`);
                    break;
                case "description-vi":
                    alert(`Can't create a translation for the ${toLanguage} description yet, please enter the description to generate.`);
                    break;
                default:
                    break;
            }
            return;
        }
        prompt = prompt + toLanguage + ": ";
        const response = await fetch(API_URL, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                Authorization: `Bearer ${API_KEY}`,
            },
            body: JSON.stringify({
                model: "gpt-4-turbo",
                messages: [{ role: "user", content: prompt + input }],
                temperature: 0,
                max_tokens: 600,
                stream: true, // For streaming responses
            }),
            signal,
        });

        const reader = response.body.getReader();
        const decoder = new TextDecoder("utf-8");

        let finalContent = "";
        while (true) {
            const { done, value } = await reader.read();
            if (done) {
                break;
            }
            const chunk = decoder.decode(value);
            const lines = chunk.split("\n");
            const parsedLines = lines
                .map((line) => line.replace(/^data: /, "").trim()) // Remove the "data: " prefix
                .filter((line) => line !== "" && line !== "[DONE]") // Remove empty lines and "[DONE]"
                .map((line) => JSON.parse(line)); // Parse the JSON string

            
            for (const parsedLine of parsedLines) {
                const { choices } = parsedLine;
                const { delta } = choices[0];
                const { content } = delta;
                if (content) {
                    finalContent += content;
                    
                    if (outputType === "editor") {
                        tinymce.get(outputId).setContent(finalContent);
                    } else {
                        $("#" + outputId).val(finalContent);
                    }
                }
            }
        }
    }
    catch (error) {
        if (signal.aborted) {
            if (outputType === "editor") {
                tinymce.get(outputId).setContent("Generation stopped.");
            } else {
                $(outputId).val("Generation stopped.");
            }
        } else {
            if (outputType === "editor") {
                tinymce.get(outputId).setContent("Error occurred while generating.");
            } else {
                $(outputId).val("Error occurred while generating.");
            }
        }
    } finally {
        controller = null;
    }
}

const stop = (e) => {
    e.preventDefault();
    if (controller) {
        controller.abort();
        controller = null;
    }
};


$(document).ready(() => {
    $(btnGenerateTitle).on("click", (e) => {
        e.preventDefault();
        generate("title");
    });
    $(btnGenerateShortDescription).on("click", (e) => {
        e.preventDefault();
        generate("short_description");
    });
    $(btnGenerateDescription).on("click", (e) => {
        e.preventDefault();
        generate("description");
    });
});