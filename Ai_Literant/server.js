require('dotenv').config();
const express = require('express');
const { GoogleGenerativeAI } = require("@google/generative-ai");

const app = express();
app.use(express.json());
app.use(express.static('public'));

const genAI = new GoogleGenerativeAI(process.env.GEMINI_API_KEY);

// Aggiungi questo nella rotta app.post('/api/chat', ...)
app.post('/api/chat', async (req, res) => {
    const startTime = Date.now();
    const { prompt } = req.body;
    
    try {
        const model = genAI.getGenerativeModel({ model: "gemini-1.5-flash" });
        const result = await model.generateContent(prompt);
        const response = await result.response;
        const text = response.text();
        
        // Calcolo metadati per la Debug Mode
        const latency = Date.now() - startTime;
        const tokens = Math.ceil(text.length / 4); // Stima approssimativa

        res.json({ 
            text, 
            debug: {
                latency: `${latency}ms`,
                tokens: tokens,
                model: "GEMINI-1.5-FLASH",
                status: "200_OK"
            }
        });
    } catch (error) {
        res.status(500).json({ error: "SYSTEM_ERR_01" });
    }
});

app.listen(3000, () => console.log('OS Online su http://localhost:3000'));