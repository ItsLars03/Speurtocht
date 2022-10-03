import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

//get specific player
router.get("/:playerId", async (req, res) => {
    const { playerId } = req.params
    const { scavengerHuntId } = req.body

    try {

        const data = await prisma.players.findFirst({
            where: {
                scavengerHunt: {
                    scavengerHuntId
                },
                playerId
            }
        })

        if (data == null) {
            res.status(404).json({
                success: false,
                message: "Player has not been found."
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

//get all players
router.get("/", async (req, res) => {
    const { scavengerHuntId } = req.body


    try {



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
    const { scavengerHuntId } = req.body


    try {

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
    const { scavengerHuntId } = req.body

    try {

    } catch (error) {
        console.error(error)
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }
})


export default router