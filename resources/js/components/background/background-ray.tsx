import { motion } from "motion/react";
import { type CSSProperties } from "react";

type BackgroundRayProps = {
  delay: number;
  duration: number;
  id: string;
  intensity: number;
  left: number;
  rotate: number;
  swing: number;
  width: number;
};

function BackgroundRay({
  delay,
  duration,
  intensity,
  left,
  rotate,
  swing,
  width,
}: BackgroundRayProps) {
  return (
    <motion.div
      className="pointer-events-none absolute -top-[12%] left-[var(--ray-left)] h-[var(--light-rays-length)] w-[var(--ray-width)] origin-top -translate-x-1/2 rounded-full bg-gradient-to-b from-[color-mix(in_srgb,var(--light-rays-color)_70%,transparent)] to-transparent opacity-0 mix-blend-screen blur-[var(--light-rays-blur)]"
      style={
        {
          "--ray-left": `${left}%`,
          "--ray-width": `${width}px`,
        } as CSSProperties
      }
      initial={{ rotate: rotate }}
      animate={{
        opacity: [0, intensity, 0],
        rotate: [rotate - swing, rotate + swing, rotate - swing],
      }}
      transition={{
        duration: duration,
        repeat: Infinity,
        ease: "easeInOut",
        delay: delay,
        repeatDelay: duration * 0.1,
      }}
    />
  );
}

export default BackgroundRay;
