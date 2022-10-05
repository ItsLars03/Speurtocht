const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()

//get specific answer from id
router.get("/:answerId", async (req, res) => {
    const { answerId } = req.params

    try {

        const data = await prisma.answers.findFirst({
            where: {
                answerId
            }
        })

        if (data == null) {
            res.status(404).json({
                success: false,
                message: "Could not find an aswer with the given id."
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

//create an answer
router.post("/", async (req, res) => {
    const { questionId, playerId, answer, correct } = req.body

    try {
        const data = await prisma.answers.create({
            data: {
                questionId,
                playerId,
                answer,
                correct
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

router.put("/:answerId", async (req, res) => {
    const { answerId } = req.params
    const { answer, correct } = req.body

    try {
        const data = await prisma.answers.update({
            where: {
                answerId,
            },
            data: {
                answer,
                correct
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

//get all from player
router.get("/player/:playerId", async (req, res) => {
    const { playerId } = req.params

    try {
        const data = prisma.answers.findMany({
            where: {
                playerId
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

router.get("/getbyquestion/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.questions.findMany({
            where: {
                scavengerHuntId
            },
            select: {
                questionId: true,
                scavengerHuntId: true,
                question: true,
                type: true,
                answers: true
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
            success: true,
            message: "Internal server error."
        })
    }
})

router.get("/getbyplayer/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.players.findMany({
            where: {
                scavengerHuntId
            },
            select: {
                playerId: true,
                scavengerHuntId: true,
                name: true,
                email: true,
                answers: true
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
            success: true,
            message: "Internal server error."
        })
    }

})

router.get("/getall/:scavengerHuntId", async (req, res) => {
    const { scavengerHuntId } = req.params

    try {
        const data = await prisma.answers.findMany({
            where: {
                questions: {
                    scavengerHuntId
                }
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
            success: true,
            message: "Internal server error."
        })
    }

})

module.exports = router