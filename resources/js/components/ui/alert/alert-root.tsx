import * as React from "react";
import { cn } from "@narsil-cms/lib/utils";
import { cva } from "class-variance-authority";
import type { VariantProps } from "class-variance-authority";

const alertVariants = cva(
  cn(
    "relative w-full rounded-md border px-4 py-3 text-sm grid grid-cols-[0_1fr] gap-y-0.5 items-start",
    "has-[>svg]:grid-cols-[calc(var(--spacing)*4)_1fr] has-[>svg]:gap-x-3",
    "[&>svg]:size-4 [&>svg]:translate-y-0.5 [&>svg]:text-current",
  ),
  {
    variants: {
      variant: {
        default: "bg-card text-card-foreground",
        destructive: cn(
          "text-destructive bg-card",
          "*:data-[slot=alert-description]:text-destructive/90",
          "[&>svg]:text-current",
        ),
      },
    },
    defaultVariants: {
      variant: "default",
    },
  },
);

type AlertRootProps = React.ComponentProps<"div"> &
  VariantProps<typeof alertVariants> & {};

function AlertRoot({ className, variant, ...props }: AlertRootProps) {
  return (
    <div
      data-slot="alert-root"
      className={cn(alertVariants({ variant }), className)}
      role="alert"
      {...props}
    />
  );
}

export default AlertRoot;
