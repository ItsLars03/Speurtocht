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
    const { id: ownerId } = req.body

    try {
        const data = await prisma.scavengerHunt.findFirst({
            where: {
                scavengerHuntId: id,
                ownerId
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
        ownerId,
        name,
        questions = [],
        status = "CLOSED",
        players = []
    } = req.body


    if (!ownerId || !name) {
        res.status(400).json({
            success: false,
            message: "ownerId and name are required fields."
        })
        return
    }

    try {
        const data = await prisma.scavengerHunt.create({
            data: {
                ownerId,
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
    const { ownerId, id } = req.body

    try {
        const deletedScavengerHunt = await prisma.scavengerHunt.delete({
            where: { scavengerHuntId: id, ownerId },
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