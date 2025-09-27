import { cn } from "@narsil-cms/lib/utils";

type InputBorderProps = React.HTMLAttributes<HTMLDivElement> & {
  duration?: number;
};

function InputBorder({
  className,
  duration = 14,
  style,
  ...props
}: InputBorderProps) {
  return (
    <div
      className={cn(
        "absolute -top-[1px] -right-[1px] -bottom-[1px] -left-[1px]",
        "pointer-events-none rounded-[inherit] border-1 border-transparent bg-size-[300%_300%] mask-exclude",
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

export { InputBorder };
