import { cn } from "@narsil-cms/lib/utils";
import { useEffect, useState, type ComponentProps, type CSSProperties } from "react";
import BackgroundRay from "./background-ray";

type BackgroundProps = Omit<ComponentProps<"div">, "color"> & {
  count?: number;
  color?: string;
  blur?: number;
  opacity?: number;
  speed?: number;
  length?: string;
  fill?: boolean;
};

const createRays = (count: number, cycle: number): ComponentProps<typeof BackgroundRay>[] => {
  if (count <= 0) {
    return [];
  }

  return Array.from({ length: count }, (_, index) => {
    const left = 8 + Math.random() * 84;
    const rotate = -28 + Math.random() * 56;
    const width = 160 + Math.random() * 160;
    const swing = 0.8 + Math.random() * 1.8;
    const delay = Math.random() * cycle;
    const duration = cycle * (0.75 + Math.random() * 0.5);
    const intensity = 0.6 + Math.random() * 0.5;

    return {
      id: `${index}-${Math.round(left * 10)}`,
      delay: delay,
      duration: duration,
      intensity: intensity,
      left: left,
      rotate: rotate,
      swing: swing,
      width: width,
    };
  });
};

function Background({
  blur = 36,
  className,
  count = 7,
  length = "75vh",
  speed = 14,
  style,
  ...props
}: BackgroundProps) {
  const [rays, setRays] = useState<ComponentProps<typeof BackgroundRay>[]>([]);

  const cycleDuration = Math.max(speed, 0.1);

  useEffect(() => {
    setRays(createRays(count, cycleDuration));
  }, [count, cycleDuration]);

  return (
    <div
      className={cn("absolute inset-0 overflow-hidden rounded-[inherit] opacity-20", className)}
      style={
        {
          "--light-rays-color": "var(--primary)",
          "--light-rays-blur": `${blur}px`,
          "--light-rays-length": length,
          ...style,
        } as CSSProperties
      }
      {...props}
    >
      <div className="absolute inset-0 overflow-hidden">
        <div
          aria-hidden
          className="absolute inset-0 opacity-60"
          style={{
            background:
              "radial-gradient(circle at 20% 15%, color-mix(in srgb, var(--light-rays-color) 45%, transparent), transparent 70%)",
          }}
        />
        <div
          aria-hidden
          className="absolute inset-0 opacity-60"
          style={{
            background:
              "radial-gradient(circle at 80% 10%, color-mix(in srgb, var(--light-rays-color) 35%, transparent), transparent 75%)",
          }}
        />
        {rays.map((ray, index) => {
          return <BackgroundRay {...ray} key={index} />;
        })}
      </div>
    </div>
  );
}

export default Background;
