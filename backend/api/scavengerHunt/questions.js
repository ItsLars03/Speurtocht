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

router.put("/:questionId", async (req, res) => {
    const { questionId } = req.params
    const { question, type } = req.body

    try {
        prisma.questions.update({
            where: {
                questionId
            },
            data: {
                question,
                type
            }
        })

    } catch (error) {
        console.error(error)

    }

})


export default router