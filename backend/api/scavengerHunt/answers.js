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

export default router