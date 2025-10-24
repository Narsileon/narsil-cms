import { cva } from "class-variance-authority";

const headingRootVariants = cva("font-medium tracking-tight text-foreground", {
  variants: {
    variant: {
      h1: "text-4xl",
      h2: "text-3xl",
      h3: "text-2xl",
      h4: "text-xl",
      h5: "text-lg",
      h6: "text-base",
    },
  },
  defaultVariants: {
    variant: "h6",
  },
});

export default headingRootVariants;
