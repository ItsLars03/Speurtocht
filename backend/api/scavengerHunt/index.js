import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/

router.get("/", async (req, res) => {
    try {
        const data = await prisma.scavengerHunt.findMany({
            select: {
                scavengerHuntId: true,
                ownerId: true,
                name: true,
                status: true,
                players: true,
                questions: true
            }
        })
        res.status(200).json({ success: true, data })
    } catch (error) {
        res.status(500).json({ success: false, message: "Internal server error." })
    }
})

router.get("/:id", async (req, res) => {
    const { id } = req.params
    const { email } = req.body

    try {
        const data = await prisma.scavengerHunt.findFirst({
            where: {
                scavengerHuntId: id,
                User: {
                    email
                }
            }
        })
        if (data == null) {
            res.status(404).json({
                success: false,
                message: "No record found with this id and email."
            })
        }

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.log(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }



})

router.post("/", async (req, res) => {
    const {
        email,
        name,
        questions = [],
        status = "CLOSED",
        players = []
    } = req.body


    if (!email || !name) {
        res.status(400).json({
            success: false,
            message: "email and name are required fields."
        })
        return
    }

    try {
        const data = await prisma.scavengerHunt.create({
            data: {
                User: {
                    connect: {
                        email
                    }
                },
                name,
                status,
                questions: questions.length > 0 ? {
                    createMany: {
                        data: questions
                    }
                } : undefined,
                players: players.length > 0 ? {
                    createMany: {
                        data: players
                    }
                } : undefined
            }
        })

        res.status(200).json({
            success: true,
            data,
        })
    } catch (error) {
        console.log(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }
})

router.delete("/", async (req, res) => {
    const { email, id } = req.body

    if (!emailRegex.test(email)) {
        res.status(500).json({
            success: false,
            message: "Not a valid email."
        })
        return
    }

    try {
        const deletedScavengerHunt = await prisma.user.update({
            where: { email },
            data: {
                scavengerHunt: {
                    delete: [{ scavengerHuntId: id }]
                }
            }
        })
        res.status(200).json({
            success: true,
            data: deletedScavengerHunt
        })
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }
})

export default router