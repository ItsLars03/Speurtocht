import { Router } from 'express'
import { PrismaClient } from '@prisma/client'
const prisma = new PrismaClient()

const router = Router()

const emailRegex = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/

router.get("/", async (req, res) => {
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
    res.status(200).json({ ...data })
})

router.post("/", async (req, res) => {

    const data = await prisma.scavengerHunt.create({
        data: {
            User: {
                connect: {
                    email: "email"
                }
            },
            name: "test",
            status: "closed",
            questions: {
                createMany: {
                    data: [
                        {
                            question: "question 1",
                            type: "text",
                            // answers: {
                            //     data: null
                            // }
                        },
                        {
                            question: "question 2",
                            type: "photo",
                            // answers: {
                            //     data: null
                            // }
                        }
                    ]
                }
            },
            players: {
                createMany: {
                    data: [
                        {
                            name: "player1",
                            email: "player1@gmail.com"
                        },
                        {
                            name: "player2",
                            email: "player2@gmail.com"
                        }
                    ]
                }
            }
        }
    })

    res.status(200).json({ ...data })
})


export default router