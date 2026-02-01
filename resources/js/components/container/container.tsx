import { mergeProps, useRender } from "@base-ui/react";
import { cn } from "@narsil-cms/lib/utils";
import { type VariantProps } from "class-variance-authority";
import containerVariants from "./container-variants";

type ContainerProps = useRender.ComponentProps<"div"> & VariantProps<typeof containerVariants>;

function Container({
  className,
  paddingBottom = "none",
  paddingTop = "none",
  render,
  variant = "md",
  ...props
}: ContainerProps) {
  return useRender({
    defaultTagName: "div",
    props: mergeProps<"div">(
      {
        className: cn(
          containerVariants({
            paddingBottom: paddingBottom,
            paddingTop: paddingTop,
            variant: variant,
          }),
          className,
        ),
      },
      props,
    ),
    render,
    state: {
      slot: "container",
      variant: variant,
    },
  });
}

export default Container;
