const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const questions = require('./questions.js')
const players = require('./players.js')
const answers = require("./answers.js")
const results = require("./results.js")

const prisma = new PrismaClient()

const router = Router()

// router.get("/", async (req, res) => {
//     try {
//         const data = await prisma.scavengerHunt.findMany({
//             select: {
//                 scavengerHuntId: true,
//                 ownerId: true,
//                 name: true,
//                 status: true,
//                 players: true,
//                 questions: true,
//             },
//         })
//         res.status(200).json({ success: true, data })
//     } catch (error) {
//         res.status(500).json({ success: false, message: "Internal server error." })
//     }
// })

router.get("/owner/:ownerId", async (req, res) => {
    const { ownerId } = req.params

    try {
        const data = await prisma.scavengerHunt.findMany({
            where: {
                ownerId
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

router.get("/", async (req, res) => {
    // const { scavengerHuntId } = req.params
    const { scavengerHuntId, ownerId } = req.body

    try {
        const data = await prisma.scavengerHunt.findFirst({
            where: {
                scavengerHuntId,
                ownerId
            },
            select: {
                scavengerHuntId: true,
                ownerId: true,
                name: true,
                status: true,
                players: true,
                questions: true
            }
        })
        if (data == null) {
            res.status(404).json({
                success: false,
                message: "No record found with this id and email."
            })
            return
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

    console.log(req.cookies)

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

router.delete("/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.scavengerHunt.delete({
            where: { scavengerHuntId },
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

router.put("/open/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.scavengerHunt.update({
            where: {
                scavengerHuntId
            },
            data: {
                status: "OPENED"
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }
})

router.use("/questions", questions)
router.use("/players", players)
router.use("/answers", answers)
router.use("/results", results)

module.exports = router