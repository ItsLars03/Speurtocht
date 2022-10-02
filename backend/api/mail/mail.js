import { Router } from "express";
import nodemailer from 'nodemailer'

const router = Router()

router.post("/send", async (req, res) => {
    const {
        html = "<html>Hello World</html>",
        text = "Hello World",
        subject = "Mail!",
        to = "p11k3t@lesonline.nu",
        from = "p11k3t@lesonline.nu"
    } = req.body

    console.log(html, text, subject)
    try {
        let transporter = nodemailer.createTransport({
            host: "mail.antagonist.nl",
            port: 465,
            secure: true, // true for 465, false for other ports
            auth: {
                user: "p11k3t3@lesonline.nu", // generated ethereal user
                pass: "e7mUNBssyG", // generated ethereal password
            },
        });

        let info = await transporter.sendMail({
            from, // sender address
            to, // list of receivers
            subject, // Subject line
            text, // plain text body
            html, // html body
        });
        res.status(200).json(info)
        return
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: error.message.includes("too many emails") ? "Too many emails have been sent." : "Internal Server Error."
        })
    }
})


export default router