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

//TODO -- just dummy data now.
router.post("/", async (req, res) => {
    /**
     * What you need:
     *  - user
     *  - name
     *  - questions?
     *  - status - default -> closed
     *  - players - default -> empty[]
     */

    const {
        email,
        name,
        questions = [],
        status = "closed",
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
                questions,
                players
            }
        })

        res.status(200).json({
            success: true,
            data,
        })
    } catch (error) {
        res.status(500).json({
            success: false,
            message: "Internal server error."
        })
    }


    // const data = await prisma.scavengerHunt.create({
    //     data: {
    //         User: {
    //             connect: {
    //                 email: "email"
    //             }
    //         },
    //         name: "test",
    //         status: "closed",
    //         questions: {
    //             createMany: {
    //                 data: [
    //                     {
    //                         question: "question 1",
    //                         type: "text",
    //                         // answers: {
    //                         //     data: null
    //                         // }
    //                     },
    //                     {
    //                         question: "question 2",
    //                         type: "photo",
    //                         // answers: {
    //                         //     data: null
    //                         // }
    //                     }
    //                 ]
    //             }
    //         },
    //         players: {
    //             createMany: {
    //                 data: [
    //                     {
    //                         name: "player1",
    //                         email: "player1@gmail.com"
    //                     },
    //                     {
    //                         name: "player2",
    //                         email: "player2@gmail.com"
    //                     }
    //                 ]
    //             }
    //         }
    //     }
    // })

    // res.status(200).json({ ...data })
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

    const idInt = parseInt(id)

    if (isNaN(idInt)) {
        res.status(500).json({
            success: false,
            message: "The id given is not a valid id."
        })
        return
    }

    try {
        const deletedScavengerHunt = await prisma.user.update({
            where: { email },
            data: {
                scavengerHunt: {
                    delete: [{ scavengerHuntId: idInt }]
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