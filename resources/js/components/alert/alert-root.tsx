import { type VariantProps } from "class-variance-authority";

import { cn } from "@narsil-cms/lib/utils";

import alertRootVariants from "./alert-root-variants";

type AlertRootProps = React.ComponentProps<"div"> &
  VariantProps<typeof alertRootVariants> & {};

function AlertRoot({ className, variant, ...props }: AlertRootProps) {
  return (
    <div
      data-slot="alert-root"
      className={cn(alertRootVariants({ variant }), className)}
      role="alert"
      {...props}
    />
  );
}

export default AlertRoot;
