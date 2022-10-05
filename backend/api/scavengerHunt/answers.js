const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()
const multer = require("multer")
const fs = require("node:fs")

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

router.route("/image").post(multer().single("image"), async (req, res) => {
    const { questionId, playerId, correct } = req.body

    console.log("body", req.body)

    console.log("file", req.file)
    let path

    try {

        const { scavengerHuntId } = await prisma.questions.findFirst({
            where: {
                questionId
            },
            select: {
                scavengerHuntId: true
            }
        })

        path = `images/${scavengerHuntId}/${questionId}/${playerId}.${req.file.originalname.split(".").pop()}`

        if (!fs.existsSync("images")) {
            fs.mkdirSync("images")
        }

        if (!fs.existsSync(`images/${scavengerHuntId}`)) {
            fs.mkdirSync(`images/${scavengerHuntId}`)
        }

        if (!fs.existsSync(`images/${scavengerHuntId}/${questionId}`)) {
            fs.mkdirSync(`images/${scavengerHuntId}/${questionId}`)
        }

        fs.stat(path, (err, cb) => {
            console.log("stats", cb)
        })

        fs.writeFileSync(`images/${scavengerHuntId}/${questionId}/${playerId}.${req.file.originalname.split(".").pop()}`, req.file.buffer)

        const data = await prisma.answers.create({
            data: {
                questionId,
                playerId,
                answer: path,
                correct: correct != null ? Boolean(correct) : correct
            }
        })

        res.status(200).json({
            success: true,
            data
        })
    } catch (error) {
        console.error(error)
        // if (path != null) fs.unlinkSync(path)
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