import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/

router.post("/", async (req, res) => {

    const { password, email } = req.body

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
                nickname: "test",
                password,
                email
            }

        })

        console.log("[LOGIN]", "user has been created", user)
        res.status(200).json({ success: true, ...user })
    } catch (error) {
        console.error(error)

        res.status(500).json({
            success: false,
            message: error.message.contains("User_email_key") ? "email already exists." : "Server error."
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

    try {
        const user = await prisma.user.findFirst({
            where: { email, password }
        })
        return {
            success: true,
            isValidUser: user != null,
            user,
        }
    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal Server Error."
        })
    }
})


export default router