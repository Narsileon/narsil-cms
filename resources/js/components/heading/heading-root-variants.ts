import { cva } from "class-variance-authority";

const headingRootVariants = cva("font-medium tracking-tight", {
  variants: {
    variant: {
      h1: "text-5xl",
      h2: "text-4xl",
      h3: "text-3xl",
      h4: "text-2xl",
      h5: "text-xl",
      h6: "base",
    },
  },
  defaultVariants: {
    variant: "h6",
  },
});

export default headingRootVariants;
