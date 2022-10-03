import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/

router.post("/", async (req, res) => {

    const { password, email, nickname } = req.body

    //maybe check weak password.

    if (!emailRegex.test(email)) {
        res.status(500).json({
            success: false,
            message: "Not a valid email."
        })
        return
    }

    try {
        const user = await prisma.user.create({
            data: {
                nickname,
                password,
                email
            }
        })

        console.log("[LOGIN]", "user has been created", user)
        res.status(200).json({ success: true, data: user })
    } catch (error) {
        console.log(error)
        res.status(500).json({
            success: false,
            message: error.message.contains("User_email_key") ? "email already exists." : "Internal server error."
        })
    }
})

router.get("/", async (req, res) => {
    const { email, password } = req.body

    if (!emailRegex.test(email)) {
        res.status(500).json({
            success: false,
            message: "Not a valid email."
        })
        return
    }

    if (!email || !password) {
        res.status(400).json({
            success: false,
            message: "Email and password are required fields."
        })
        return
    }

    try {
        const user = await prisma.user.findFirst({
            where: { email, password }
        })
        if (user == null) {
            res.status(404).json({
                success: false,
                message: "Could not find the user with these credentials."
            })
            return
        }
        res.status(200).json({
            success: true,
            data: user,
        })
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal Server Error."
        })
    }
})


export default router