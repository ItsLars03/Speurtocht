const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()


router.post("/", async (req, res) => {
    const { scavengerHuntId, question, type } = req.body

    try {
        const data = await prisma.scavengerHunt.update({
            where: { scavengerHuntId },
            data: {
                questions: {
                    create: {
                        question,
                        type
                    }
                }
            },
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

router.put("/:questionId", async (req, res) => {
    const { questionId } = req.params
    const { question, type } = req.body

    console.log("question", question)
    console.log("type", type)

    try {
        const data = await prisma.questions.update({
            where: {
                questionId
            },
            data: {
                question,
                type
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

router.get("/random/:playerId", async (req, res) => {
    const { playerId } = req.params

    try {
        const playerData = await prisma.players.findFirst({
            where: {
                playerId
            }
        })

        if (!playerData) {
            res.status(404).json({
                success: false,
                message: "Could not find the specified player."
            })
            return
        }

        const data = await prisma.questions.findMany({
            where: {
                scavengerHuntId: playerData.scavengerHuntId,
                answers: {
                    none: {
                        playerId
                    }
                }
            }
        })

        res.status(200).json({
            success: true,
            data: data[Math.floor(Math.random() * data.length)],
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