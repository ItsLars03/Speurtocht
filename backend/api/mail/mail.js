const { Router } = require("express")
const nodemailer = require('nodemailer')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()

router.post("/send", async (req, res) => {
    const {
        html = "<html>Hello World</html>",
        text = "Hello World",
        subject = "Mail!",
        to = "p11k3t@lesonline.nu",
        from = "p11k3t@lesonline.nu"
    } = req.body

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

//get all from scavengerHunt
router.get("/scavengerhunt/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.emails.findMany({
            where: {
                scavengerHuntId
            },
            orderBy: {
                createdAt: "asc"
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})

//get specific email from emailId
router.get("/:emailId", async (req, res) => {
    const { emailId } = req.params

    try {
        const data = await prisma.emails.findFirst({
            where: {
                emailId
            }
        })

        if (data == null) {
            res.status(404).json({
                success: false,
                message: "Could not find an email with the specified id."
            })
            return
        }

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})


//create one for scavengerHunt
router.post("/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params
    const { email } = req.body

    try {
        const data = await prisma.emails.create({
            data: {
                scavengerHuntId,
                email
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }

})


module.exports = router