const { Router } = require('express')
const { PrismaClient } = require('@prisma/client')
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/


//get specific player
// router.get("/:playerId", async (req, res) => {
//     const { playerId } = req.params

//     try {

//         const data = await prisma.players.findFirst({
//             where: {
//                 playerId
//             }
//         })

//         if (data == null) {
//             res.status(404).json({
//                 success: false,
//                 message: "Player has not been found."
//             })
//             return
//         }

//         res.status(200).json({
//             success: true,
//             data
//         })
//     } catch (error) {
//         console.error(error)
//         res.status(500).json({
//             success: false,
//             message: "Internal server error."
//         })
//     }


// })

//get all players
router.get("/", async (req, res) => {
    const { scavengerHuntId } = req.body

    try {
        const data = await prisma.players.findMany({
            where: {
                scavengerHuntId
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

//update player
router.put("/:playerId", async (req, res) => {
    const { playerId } = req.params
    const { name, email } = req.body

    try {

        const data = await prisma.players.update({
            where: {
                playerId
            },
            data: {
                name,
                email
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

//create player
router.post("/", async (req, res) => {
    const { scavengerHuntId, name, email } = req.body

    if (!emailRegex.test(email)) {
        res.status(400).json({
            success: false,
            message: "Invalid email."
        })
        return
    }

    try {
        const data = await prisma.players.create({
            data: {
                scavengerHuntId,
                name,
                email
            },

        })

        //delete emails as the player has joined.
        prisma.emails.deleteMany({
            where: {
                email,
                scavengerHuntId
            }
        }).catch(() => { })

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

router.delete("/:playerId", async (req, res) => {
    const { playerId } = req.params

    try {

        const data = await prisma.players.delete({
            where: {
                playerId
            },
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

module.exports = router