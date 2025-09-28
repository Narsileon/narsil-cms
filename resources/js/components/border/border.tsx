import { cn } from "@narsil-cms/lib/utils";

type BorderProps = React.HTMLAttributes<HTMLDivElement> & {
  duration?: number;
};

function Border({ className, duration = 14, style, ...props }: BorderProps) {
  return (
    <div
      className={cn(
        "absolute -top-0.5 -right-0.5 -bottom-0.5 -left-0.5",
        "pointer-events-none rounded-[inherit] border-2 border-transparent bg-size-[300%_300%] mask-exclude",
        "infinite linear will-change-[background-position] motion-safe:animate-shine",
        className,
      )}
      style={
        {
          "--duration": `${duration}s`,
          backgroundImage: `radial-gradient(transparent,transparent,var(--primary),var(--secondary),transparent,transparent)`,
          mask: `linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0)`,
          WebkitMask: `linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0)`,
          WebkitMaskComposite: "xor",
          ...style,
        } as React.CSSProperties
      }
      {...props}
    />
  );
}

export { Border };
